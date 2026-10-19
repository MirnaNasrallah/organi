/** @type {import('prettier').Config} */
// tabWidth is explicit because the root .editorconfig says 4 spaces, for PHP (PSR-12).
export default {
  printWidth: 120,
  tabWidth: 2,
  singleQuote: true,
  trailingComma: 'all',
};
