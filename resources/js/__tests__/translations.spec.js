import en from '../../../lang/en.json';
import ar from '../../../lang/ar.json';

describe('translation keys', () => {
  const enKeys = Object.keys(en).sort();
  const arKeys = Object.keys(ar).sort();

  it('english keys match snapshot', () => {
    expect(enKeys).toMatchSnapshot();
  });

  it('arabic contains all english keys', () => {
    expect(arKeys).toEqual(enKeys);
  });
});
