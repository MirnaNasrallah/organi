import { theme } from '@lockmate/tokens';
import appJson from '../app.json';

// app.json is static, so it can't read the tokens: these checks keep its brand colours from drifting.
const { android, plugins } = appJson.expo;

function pluginOptions(name: string): unknown {
  const entry = plugins.find((plugin) => Array.isArray(plugin) && plugin[0] === name);
  return Array.isArray(entry) ? entry[1] : undefined;
}

describe('app.json brand colours', () => {
  it('puts the Android icon leaves on forest', () => {
    expect(android.adaptiveIcon.backgroundColor).toBe(theme.colors.light.brand);
  });

  it('shows the splash on the dew background, and its dark counterpart in dark mode', () => {
    expect(pluginOptions('expo-splash-screen')).toMatchObject({
      backgroundColor: theme.colors.light.bg,
      dark: { backgroundColor: theme.colors.dark.bg },
    });
  });
});
