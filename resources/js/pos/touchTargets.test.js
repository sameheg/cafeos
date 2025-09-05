const { enforceTouchTargets } = require('./touchTargets');

describe('touch targets', () => {
  test('buttons and inputs receive minimum size', () => {
    const btn = { style: {} };
    const inp = { style: {} };
    const root = { querySelectorAll: () => [btn, inp] };
    enforceTouchTargets(root);
    expect(parseInt(btn.style.minHeight)).toBeGreaterThanOrEqual(44);
    expect(parseInt(btn.style.minWidth)).toBeGreaterThanOrEqual(44);
    expect(parseInt(inp.style.minHeight)).toBeGreaterThanOrEqual(44);
    expect(parseInt(inp.style.minWidth)).toBeGreaterThanOrEqual(44);
  });
});
