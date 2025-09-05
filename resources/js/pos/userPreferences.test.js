const { loadPreferences, savePreferences } = require('./userPreferences');

describe('user preferences', () => {
  beforeEach(() => {
    const store = {};
    global.localStorage = {
      getItem: key => Object.prototype.hasOwnProperty.call(store, key) ? store[key] : null,
      setItem: (key, val) => { store[key] = val; },
      clear: () => { for (const k in store) delete store[k]; }
    };
    localStorage.clear();
  });

  test('saves and loads settings', () => {
    savePreferences({ language: 'en', color: 'dark', layout: 'grid' });
    const prefs = loadPreferences();
    expect(prefs).toEqual({ language: 'en', color: 'dark', layout: 'grid' });
  });
});
