// WCAG 2.x contrast ratio between two #RRGGBB colours.
export function contrastRatio(foreground: string, background: string): number {
  const [a, b] = [luminance(foreground), luminance(background)];
  return (Math.max(a, b) + 0.05) / (Math.min(a, b) + 0.05);
}

function luminance(hex: string): number {
  const red = channel(hex, 1);
  const green = channel(hex, 3);
  const blue = channel(hex, 5);
  return 0.2126 * red + 0.7152 * green + 0.0722 * blue;
}

function channel(hex: string, offset: number): number {
  const value = Number.parseInt(hex.slice(offset, offset + 2), 16) / 255;
  return value <= 0.03928 ? value / 12.92 : ((value + 0.055) / 1.055) ** 2.4;
}
