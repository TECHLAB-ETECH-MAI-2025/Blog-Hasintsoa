import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export const wait = (duration: number = 1000) => {
  return new Promise((resolve, _) => {
    window.setTimeout(resolve, duration);
  })
}

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}