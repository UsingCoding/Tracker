export default class Strings
{
    static capitalizeFirstLetter(string) 
    {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    static trimString(string) 
    {
        const length = 50;
        return string.length > length ? string.substring(0, length - 3) + "..." : string;
    }
}