import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { useFonts } from 'expo-font';
import { Stack } from 'expo-router';
import { StatusBar } from 'expo-status-bar';
import { useState } from 'react';
import { deviceLocale, LocaleProvider } from '../locale';
import { fontFiles } from '../ui/fonts';

export default function RootLayout() {
  const [fontsLoaded, fontError] = useFonts(fontFiles);
  const [queryClient] = useState(() => new QueryClient());
  const [locale] = useState(deviceLocale);

  // If the fonts fail to load, carry on with the system font rather than a blank screen.
  if (!fontsLoaded && !fontError) {
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
