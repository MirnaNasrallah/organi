import { Text as NativeText, type TextProps } from 'react-native';
import { useLocale } from '../locale';
import { textStyle, useColors, type ColorName, type TextVariant } from './theme';

type Props = Pick<TextProps, 'accessibilityRole' | 'children' | 'numberOfLines'> & {
  variant?: TextVariant;
  color?: ColorName;
};

export function Text({ variant = 'body', color = 'ink', ...props }: Props) {
  const colors = useColors();
  const locale = useLocale();
  return <NativeText {...props} style={[textStyle(variant, locale), { color: colors[color] }]} />;
}
