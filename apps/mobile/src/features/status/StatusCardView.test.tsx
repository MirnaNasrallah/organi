import type { Locale } from '@lockmate/i18n';
import { fireEvent, render, screen } from '@testing-library/react-native';
import { LocaleProvider } from '../../locale';
import { StatusCardView, type StatusState } from './StatusCardView';

async function renderIn(locale: Locale, state: StatusState, onRetry = jest.fn()) {
  await render(
    <LocaleProvider locale={locale}>
      <StatusCardView state={state} onRetry={onRetry} />
    </LocaleProvider>,
  );
  return onRetry;
}

describe('StatusCardView', () => {
  it('says which language the API answered in, in English', async () => {
    await renderIn('en', { kind: 'connected', locale: 'en' });

    expect(screen.getByText('Connected')).toBeOnTheScreen();
    expect(screen.getByText('Answering in English')).toBeOnTheScreen();
  });

  it('says it in Arabic for Arabic users', async () => {
    await renderIn('ar', { kind: 'connected', locale: 'ar' });

    expect(screen.getByText('متصل')).toBeOnTheScreen();
    expect(screen.getByText('الردود باللغة العربية')).toBeOnTheScreen();
  });

  it('shows progress while checking', async () => {
    await renderIn('en', { kind: 'checking' });

    expect(screen.getByText('Checking…')).toBeOnTheScreen();
    expect(screen.queryByRole('button')).toBeNull();
  });

  it('offers a retry when the API is unreachable', async () => {
    const onRetry = await renderIn('ar', { kind: 'unreachable' });

    expect(screen.getByText('تعذّر الوصول إلى الخدمة')).toBeOnTheScreen();
    await fireEvent.press(screen.getByRole('button', { name: 'إعادة المحاولة' }));
    expect(onRetry).toHaveBeenCalledTimes(1);
  });
});
