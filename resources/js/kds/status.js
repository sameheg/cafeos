const socket = new WebSocket('ws://localhost:3000');

socket.addEventListener('message', event => {
  const ticket = JSON.parse(event.data);
  const el = document.querySelector(`#ticket-${ticket.id} .status`);
  if (el) {
    el.textContent = ticket.status;
  }
});

function sendStatus(id, status) {
  fetch(`/api/kds/tickets/${id}/status`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ status })
  });
}

document.querySelectorAll('[data-ticket][data-status]').forEach(btn => {
  btn.addEventListener('click', () => {
    sendStatus(btn.dataset.ticket, btn.dataset.status);
  });
});
