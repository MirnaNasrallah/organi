// English is the source language: every key starts here (CONTEXT §3).
export const en = {
  'app.name': 'Lockmate',
  'app.tagline': "Lock in. We've got you.",
  'language.en': 'English',
  'language.ar': 'Arabic',
  'status.title': 'API status',
  'status.checking': 'Checking…',
  'status.connected': 'Connected',
  'status.answeringIn': 'Answering in {language}',
  'status.unreachable': "Can't reach the API",
  'status.retry': 'Try again',
} as const;

export type MessageKey = keyof typeof en;
