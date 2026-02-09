import messagesComponent from './components/messages.js';

// Expose for Alpine x-data
window.messagesComponent = messagesComponent;

// If Alpine is present, nothing more is needed — the view will pick up x-data
console.log('Main script loaded');
