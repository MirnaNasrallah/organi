import { theme } from '@lockmate/tokens';
import { fontFamily } from './fonts';
import { textStyle, type TextVariant } from './theme';

const variants = Object.keys(theme.text) as TextVariant[];

describe('textStyle', () => {
  it.each(variants)('loads a Rubik font for the %s style', (variant) => {
    expect(() => textStyle(variant, 'en')).not.toThrow();
  });

  it('keeps tracking in English but drops it in Arabic, where it breaks the letter joins', () => {
    expect(textStyle('eyebrow', 'en').letterSpacing).toBe(theme.text.eyebrow.letterSpacing);
    expect(textStyle('eyebrow', 'ar')).not.toHaveProperty('letterSpacing');
  });

  it('lines numbers up with tabular figures in the metric style', () => {
    expect(textStyle('metric', 'ar').fontVariant).toEqual(['tabular-nums']);
    expect(textStyle('body', 'en')).not.toHaveProperty('fontVariant');
  });
});

describe('fontFamily', () => {
  it('refuses a weight whose font is not loaded', () => {
    expect(() => fontFamily(800)).toThrow(/weight 800/);
  });
});
