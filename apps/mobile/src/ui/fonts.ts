// One entry point per weight: the package root would bundle all 14 Rubik files (~2.9 MB).
import { Rubik_400Regular } from '@expo-google-fonts/rubik/400Regular';
import { Rubik_500Medium } from '@expo-google-fonts/rubik/500Medium';
import { Rubik_600SemiBold } from '@expo-google-fonts/rubik/600SemiBold';

/** Font files for `useFonts`. Their keys become the family names. */
export const fontFiles = { Rubik_400Regular, Rubik_500Medium, Rubik_600SemiBold };

type Family = keyof typeof fontFiles;

// Android can't choose a weight within one family, so each weight is its own family (ADR 0005).
const FAMILY_BY_WEIGHT: Record<number, Family> = {
  400: 'Rubik_400Regular',
  500: 'Rubik_500Medium',
  600: 'Rubik_600SemiBold',
};

export function fontFamily(weight: number): Family {
  const family = FAMILY_BY_WEIGHT[weight];
  if (family === undefined) {
    throw new Error(`No Rubik font is loaded for weight ${weight}: add it to fontFiles`);
  }
  return family;
}
