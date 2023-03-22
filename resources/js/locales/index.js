import en from './langs/en.json';
import ru from './langs/ru.json';

export const defaultLocale = localStorage.getItem('lang-locale') ?? 'en';

export const languages = {
    en, ru
};