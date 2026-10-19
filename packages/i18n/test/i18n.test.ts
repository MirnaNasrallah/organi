import assert from 'node:assert/strict';
import { describe, it } from 'node:test';
import { direction, resolveLocale, translate } from '../src/index.ts';

describe('translate', () => {
  it('returns the message in the requested language', () => {
    assert.equal(translate('en', 'status.connected'), 'Connected');
    assert.equal(translate('ar', 'status.connected'), 'متصل');
  });

  it('fills placeholders and leaves unknown ones visible', () => {
    assert.equal(translate('en', 'status.answeringIn', { language: 'Arabic' }), 'Answering in Arabic');
    assert.equal(translate('en', 'status.answeringIn'), 'Answering in {language}');
  });
});

describe('resolveLocale', () => {
  it('takes the first supported language from the preference list', () => {
    assert.equal(resolveLocale(['ar-EG', 'en-US']), 'ar');
    assert.equal(resolveLocale(['fr-FR', 'en-GB', 'ar']), 'en');
    assert.equal(resolveLocale(['fr-FR', 'AR']), 'ar');
  });

  it('falls back to English when nothing matches', () => {
    assert.equal(resolveLocale(['fr-FR', 'de']), 'en');
    assert.equal(resolveLocale([]), 'en');
  });
});

describe('direction', () => {
  it('lays Arabic out right to left and English left to right', () => {
    assert.equal(direction('ar'), 'rtl');
    assert.equal(direction('en'), 'ltr');
  });
});
