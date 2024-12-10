// src/utils/global.ts
let globalString: string = "Initial value"; // The string variable you want to share
let globalString2: string = "Initial value"; // The string variable you want to share
let globalString3: string = "Initial value"; // The string variable you want to share
let globalString4: string = "Initial value"; // The string variable you want to share
let globalString5: string = "Initial value"; // The string variable you want to share
let globalString6: string = "Initial value"; // The string variable you want to share

export const getGlobalString = (): string => globalString; // Function to get the string
export const setGlobalString = (newValue: string): void => {
  globalString = newValue;
}; // Function to set the string

export const getGlobalString2 = (): string => globalString2; // Function to get the string
export const setGlobalString2 = (newValue2: string): void => {
  globalString2 = newValue2;
}; // Function to set the string

export const getGlobalString3 = (): string => globalString3; // Function to get the string
export const setGlobalString3 = (newValue3: string): void => {
  globalString3 = newValue3;
}; // Function to set the string

export const getGlobalString4 = (): string => globalString4; // Function to get the string
export const setGlobalString4 = (newValue4: string): void => {
  globalString4 = newValue4;
}; // Function to set the string

export const getGlobalString5 = (): string => globalString5; // Function to get the string
export const setGlobalString5 = (newValue5: string): void => {
  globalString5 = newValue5;
}; // Function to set the string

export const getGlobalString6 = (): string => globalString6; // Function to get the string
export const setGlobalString6 = (newValue6: string): void => {
  globalString6 = newValue6;
}; // Function to set the string
