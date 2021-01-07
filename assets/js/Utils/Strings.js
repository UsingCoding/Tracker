export default class Strings
{

    constructor()
    {

    }

    static capitalizeFirstLetter(string) 
    {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    trimString(string) 
    {
        const length = 35;
        return string.length > length ? string.substring(0, length - 3) + "..." : string;
    }
}