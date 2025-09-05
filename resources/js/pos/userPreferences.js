const KEY = 'pos-settings';

function loadPreferences () {
  try {
    return JSON.parse(localStorage.getItem(KEY)) || {};
  } catch (e) {
    return {};
  }
}

function savePreferences (prefs) {
  localStorage.setItem(KEY, JSON.stringify(prefs));
}

module.exports = { loadPreferences, savePreferences };
