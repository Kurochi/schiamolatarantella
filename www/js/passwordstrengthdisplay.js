function passwordStrength(password)
{
    var i;

    var matches = password.match(/[a-z]+/g);
    var lowercaseCharacters = 0;

    if (matches != null) {
        for (i = 0; i < matches.length; i++) {
            lowercaseCharacters += matches[i].length;
        }
    }

    matches = password.match(/[A-Z]+/g);
    var uppercaseCharacters = 0;
    if (matches != null) {
        for (i = 0; i < matches.length; i++) {
            uppercaseCharacters += matches[i].length;
        }
    }

    matches = password.match(/\d+/g);
    var numericCharacters = 0;

    if (matches != null) {
        for (i = 0; i < matches.length; i++) {
            numericCharacters += matches[i].length;
        }
    }

    matches = password.match(/\W+/g);
    var nonWordCharacters = 0;

    if (matches != null) {
        for (i = 0; i < matches.length; i++) {
            nonWordCharacters += matches[i].length;
        }
    }

    var length = lowercaseCharacters + uppercaseCharacters + numericCharacters + nonWordCharacters;

    var charTypes = 0;
    charTypes = (lowercaseCharacters > 0) ? ++charTypes : charTypes;
    charTypes = (uppercaseCharacters > 0) ? ++charTypes : charTypes;
    charTypes = (numericCharacters > 0) ? ++charTypes : charTypes;
    charTypes = (nonWordCharacters > 0) ? ++charTypes : charTypes;

    return length + Math.max(charTypes - 1, 0) * 3;
}

function PasswordStrengthDisplay(parentElement, minPasswordStrength, displayClass, prefix)
{
    displayClass = displayClass || "password_strength_display";
    prefix = prefix || "Strength";

    var $displayContainer = $("<div><div class='progress'></div></div>");
    $displayContainer.addClass(displayClass);

    var $displayStrength = function (strength)
    {
        var percent = strength / minPasswordStrength;
        if (percent >= 1)
        {
            $displayContainer.removeClass();
            $displayContainer.addClass(displayClass + " p100");
        }
        else if (percent >= 0.75)
        {
            $displayContainer.removeClass();
            $displayContainer.addClass(displayClass + " p75");
        }
        else if (percent >= 0.50)
        {
            $displayContainer.removeClass();
            $displayContainer.addClass(displayClass + " p50");
        }
        else if (percent >= 0.25)
        {
            $displayContainer.removeClass();
            $displayContainer.addClass(displayClass + " p25");
        }
        else
        {
            $displayContainer.removeClass();
            $displayContainer.addClass(displayClass + " p0");
        }

        $displayContainer.html(prefix + ": " + Math.floor(percent * 100) + "%");
    };

    parentElement.after($displayContainer);
    parentElement.bind("keyup", function()
    {
        var val = $(this).val();
        var strength = passwordStrength(val);

        $displayStrength(strength);
    });
}