import type { Locale } from '@lockmate/i18n';
import { useTranslate } from '../../locale';
import { Button } from '../../ui/Button';
import { Card } from '../../ui/Card';
import { Text } from '../../ui/Text';

export type StatusState = { kind: 'checking' } | { kind: 'connected'; locale: Locale } | { kind: 'unreachable' };

/** What the API said, in the user's language. `locale` is the language the API answered in. */
export function StatusCardView({ state, onRetry }: { state: StatusState; onRetry: () => void }) {
  const t = useTranslate();

  return (
    <Card>
      <Text variant="label" color="inkMuted">
        {t('status.title')}
      </Text>

      {state.kind === 'checking' && <Text>{t('status.checking')}</Text>}

      {state.kind === 'connected' && (
        <>
          <Text variant="heading" color="brand">
            {t('status.connected')}
          </Text>
          <Text color="inkMuted">{t('status.answeringIn', { language: t(`language.${state.locale}`) })}</Text>
        </>
      )}

      {state.kind === 'unreachable' && (
        <>
          <Text variant="heading" color="danger">
            {t('status.unreachable')}
          </Text>
          <Button label={t('status.retry')} onPress={onRetry} />
        </>
      )}
    </Card>
  );
}
