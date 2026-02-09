// Minimal Alpine-compatible messages component used by the view
export default function messagesComponent() {
  return {
    conversations: [],
    filteredConversations: [],
    selectedConversation: null,
    currentMessages: [],
    newMessage: '',
    sidebarVisible: false,
    searchQuery: '',
    emojis: ['😀','😁','😅','😍','🤔','👍','🎉'],
    showEmojiPicker: false,
    lastRefresh: null,
    init() {
      console.log('Messages component initializing...');
      console.log('Current user:', window.CURRENT_USER);
      console.log('Available users:', window.AVAILABLE_USERS);
      
      // load initial messages
      this.loadUsers();
      this.loadAll();
      // start polling for new messages
      setInterval(()=> this.refresh(), 5000);
    },
    mapMessages(raw) {
      const meId = window.CURRENT_USER?.id || null;
      return (raw || []).map(m => ({
        id: m.id,
        sender_id: m.sender_id ?? m.senderId ?? null,
        receiver_id: m.receiver_id ?? m.receiverId ?? null,
        text: m.text || m.message || '',
        is_read: Number(m.is_read || m.isRead || 0),
        created_at: m.created_at || m.createdAt || new Date().toISOString(),
        sent: Number(m.sender_id || m.senderId || 0) === Number(meId),
        read: Number(m.is_read || m.isRead || 0) === 1,
        time: (new Date(m.created_at || m.createdAt || Date.now())).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
      }));
    },
    async loadAll() {
      try {
        const res = await fetch('/api/messages');
        const data = await res.json();
        if (data.ok) {
          // Map messages and keep newest last
          const mapped = this.mapMessages(data.messages || []);
          this.currentMessages = mapped.slice().reverse();
          if (mapped.length) {
            this.lastRefresh = mapped[mapped.length - 1].created_at;
          }
        }
      } catch (e) {
        console.error('Failed to load messages', e);
      }
    },
    async loadUsers() {
      try {
        // Use users passed from server first, then fallback to API
        let users = window.AVAILABLE_USERS || [];
        
        if (!users.length) {
          const res = await fetch('/api/users');
          const data = await res.json();
          if (data.ok) {
            users = data.users || [];
          }
        }
        
        // map users into conversation items (exclude current user)
        const meId = window.CURRENT_USER?.id || null;
        this.conversations = users
          .filter(u => u.id != meId)
          .map(u => ({
            id: u.id,
            name: u.nom || u.email || 'User ' + u.id,
            avatar: '/assets/images/avatar-placeholder.svg',
            online: false,
            lastMessage: 'Cliquez pour commencer une conversation',
            lastMessageTime: '',
            unread: 0,
            type: 'user',
            lastSeen: null
          }));
        this.filteredConversations = this.conversations;
        
        console.log('Users loaded:', this.conversations.length, 'conversations');
      } catch (e) { 
        console.error('Failed to load users', e); 
      }
    },
    async refresh() {
      try {
        const url = '/api/messages/refresh' + (this.lastRefresh ? ('?since=' + encodeURIComponent(this.lastRefresh)) : '');
        const res = await fetch(url);
        const data = await res.json();
        if (data.ok && data.messages.length) {
          // map and append new messages
          const mapped = this.mapMessages(data.messages || []);
          this.currentMessages = this.currentMessages.concat(mapped);
          this.lastRefresh = mapped[mapped.length - 1].created_at;
        }
      } catch (e) {
        console.error('refresh failed', e);
      }
    },
    selectConversation(conversation) {
      this.selectedConversation = conversation;
      // load conversation messages
      this.loadConversation(conversation.id);
    },

    async loadConversation(otherId) {
      try {
        const url = '/api/messages/conversation?with=' + encodeURIComponent(otherId);
        const res = await fetch(url);
        const data = await res.json();
        if (data.ok) {
          this.currentMessages = this.mapMessages(data.messages || []);
        }
      } catch (e) { console.error('loadConversation failed', e); }
    },
    filterConversations() {
      // Not implemented: keep as pass-through
      this.filteredConversations = this.conversations;
    },
    handleTyping() {},
    autoResize(e) {
      const t = e.target; t.style.height = 'auto'; t.style.height = (t.scrollHeight) + 'px';
    },
    addEmoji(emoji) { this.newMessage += emoji; this.showEmojiPicker = false; },
    toggleEmojiPicker() { this.showEmojiPicker = !this.showEmojiPicker; },
    toggleAttachment() {},
    newConversation() { 
      if (this.conversations.length === 0) {
        alert('Aucun utilisateur disponible pour démarrer une conversation.');
      } else {
        alert('Sélectionnez un utilisateur dans la liste à gauche pour démarrer une conversation.');
      }
    },
    videoCall() {}, voiceCall() {}, muteConversation() {}, archiveConversation() {}, deleteConversation() {},
    async sendMessage() {
      if (!this.newMessage.trim()) return;
      if (!this.selectedConversation) { alert('Sélectionnez un destinataire dans la liste à gauche.'); return; }
      const to = this.selectedConversation.id;
      
      console.log('Sending message:', {
        to_user_id: to,
        text: this.newMessage,
        from_user: window.CURRENT_USER?.id
      });
      
      try {
        const fd = new FormData();
        fd.append('to_user_id', to);
        fd.append('text', this.newMessage);
        const res = await fetch('/api/messages/send', { method: 'POST', body: fd });
        const data = await res.json();
        
        console.log('Send response:', data);
        
        if (data.ok) {
          const now = new Date().toISOString();
          this.currentMessages.push({ id: data.message_id, sender_id: window.CURRENT_USER?.id || null, receiver_id: to, text: this.newMessage, is_read: 0, created_at: now, sent: true, read: false, time: (new Date(now)).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'}) });
          this.newMessage = '';
        } else {
          alert('Failed to send message: ' + (data.error || 'Unknown error'));
        }
      } catch (e) { 
        console.error('send error', e); 
        alert('Network error: ' + e.message);
      }
    }
  };
}
