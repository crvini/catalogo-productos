import { setupHandlers } from './handlers.js';
import { setCSRFToken } from './api.js';

$(function () {
  setCSRFToken();
  setupHandlers();
});
