import shared from '@lockmate/config/eslint';
import { defineConfig, globalIgnores } from 'eslint/config';
import reactHooks from 'eslint-plugin-react-hooks';

// Physical sides break the Arabic (RTL) layout: use start/end instead (RULES §11).
const PHYSICAL_SIDE = /^(margin|padding|border)(Left|Right)|^(left|right)$|^border(Top|Bottom)(Left|Right)Radius$/;

export default defineConfig(globalIgnores(['.expo/', 'dist/']), shared, reactHooks.configs.flat['recommended-latest'], {
  files: ['**/*.tsx'],
  rules: {
    'no-restricted-syntax': [
      'error',
      {
        selector: `Property[key.name=${PHYSICAL_SIDE}]`,
        message: 'Use start/end (marginStart, paddingEnd, start, end…) so the layout mirrors in Arabic.',
      },
    ],
  },
});
