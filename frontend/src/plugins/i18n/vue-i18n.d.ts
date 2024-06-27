/**
 * global type definitions
 * using the typescript interface, you can define the i18n resources that is type-safed!
 */

/**
 * you need to import the some interfaces
 */
import vi from '@/plugins/i18n/locales/vi.json';
import 'vue-i18n';

type LocaleMessage = typeof vi

declare module 'vue-i18n' { 
  export interface DefineLocaleMessage extends LocaleMessage {
  }
}
