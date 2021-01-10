export default class Strings
{

    constructor()
    {

    }

    static capitalizeFirstLetter(string) 
    {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    trimString(string, length) 
    {
        return string.length > length ? string.substring(0, length - 3) + "..." : string;
    }
}