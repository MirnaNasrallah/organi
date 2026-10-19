import type { ReactNode } from 'react';
import { StyleSheet, View } from 'react-native';
import { radius, space, useColors } from './theme';

/** A flat surface with a hairline border: the brand uses lines, never shadows. */
export function Card({ children }: { children: ReactNode }) {
  const colors = useColors();
  return (
    <View
      style={{
        backgroundColor: colors.surface,
        borderColor: colors.line,
        borderWidth: StyleSheet.hairlineWidth,
        borderRadius: radius.md,
        padding: space[4],
        gap: space[2],
      }}
    >
      {children}
    </View>
  );
}
