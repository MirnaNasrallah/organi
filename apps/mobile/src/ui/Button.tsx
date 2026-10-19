import { Pressable } from 'react-native';
import { Text } from './Text';
import { radius, size, space, useColors } from './theme';

const PRESSED_OPACITY = 0.8;

/** The primary action: a forest pill, never smaller than the touch target. */
export function Button({ label, onPress }: { label: string; onPress: () => void }) {
  const colors = useColors();
  return (
    <Pressable
      accessibilityRole="button"
      onPress={onPress}
      style={({ pressed }) => ({
        alignSelf: 'flex-start',
        alignItems: 'center',
        justifyContent: 'center',
        minHeight: size.touchTarget,
        minWidth: size.touchTarget,
        paddingHorizontal: space[6],
        borderRadius: radius.full,
        backgroundColor: colors.brand,
        opacity: pressed ? PRESSED_OPACITY : 1,
      })}
    >
      <Text variant="label" color="onBrand">
        {label}
      </Text>
    </Pressable>
  );
}
