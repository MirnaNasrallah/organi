import type { MessageKey } from './en.ts';

// Typed against English, so a missing or misspelled key fails the type check.
// Written for Arabic readers, not translated word for word (brand voice); needs a native review before launch.
export const ar: Record<MessageKey, string> = {
  'app.name': 'Lockmate',
  'app.tagline': 'التزم، ونحن معك.',
  'language.en': 'الإنجليزية',
  'language.ar': 'العربية',
  'status.title': 'حالة الخدمة',
  'status.checking': 'جارٍ التحقق…',
  'status.connected': 'متصل',
  'status.answeringIn': 'الردود باللغة {language}',
  'status.unreachable': 'تعذّر الوصول إلى الخدمة',
  'status.retry': 'إعادة المحاولة',
};
