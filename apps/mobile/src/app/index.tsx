import { View } from 'react-native';
import { StatusCard } from '../features/status/StatusCard';
import { useTranslate } from '../locale';
import { Screen } from '../ui/Screen';
import { Text } from '../ui/Text';
import { space } from '../ui/theme';

export default function Home() {
  const t = useTranslate();

  return (
    <Screen>
      <View style={{ gap: space[2] }}>
        <Text variant="display" color="brand" accessibilityRole="header">
          {t('app.name')}
        </Text>
        <Text variant="title">{t('app.tagline')}</Text>
      </View>
      <StatusCard />
    </Screen>
  );
}
