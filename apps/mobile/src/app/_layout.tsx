import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { useFonts } from 'expo-font';
import { Stack } from 'expo-router';
import * as SplashScreen from 'expo-splash-screen';
import { StatusBar } from 'expo-status-bar';
import { useEffect, useState } from 'react';
import { deviceLocale, LocaleProvider } from '../locale';
import { fontFiles } from '../ui/fonts';

// Keep the native splash up until Rubik has loaded, so the first frame is already on brand.
void SplashScreen.preventAutoHideAsync();

export default function RootLayout() {
  const [fontsLoaded, fontError] = useFonts(fontFiles);
  const [queryClient] = useState(() => new QueryClient());
  const [locale] = useState(deviceLocale);

  // If the fonts fail to load, carry on with the system font rather than a stuck splash.
  const ready = fontsLoaded || fontError !== null;

  useEffect(() => {
    if (ready) {
      SplashScreen.hide();
    }
  }, [ready]);

  if (!ready) {
    return null;
  }

  return (
    <LocaleProvider locale={locale}>
      <QueryClientProvider client={queryClient}>
        <StatusBar style="auto" />
        <Stack screenOptions={{ headerShown: false }} />
      </QueryClientProvider>
    </LocaleProvider>
  );
}
