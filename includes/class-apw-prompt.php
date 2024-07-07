<?php

class APW_Prompt {
    public static function create_prompt($style, $writing, $language, $template) {
        return "$template \n\nPlease format this result using Markdown and Please use Language Style \"$style\" with Writing Style \"$writing\" and Write in \"$language\"";
    }

    public static function create_promptV2($language, $template) {
        return "$template \n\nPlease use $language language and Make sure to follow the following format:
Use the # sign for the main heading.
Use the ## sign for the main subheading.
Use the ### sign for the secondary subheading.
Use the - sign for items in a list.
Use appropriate indentation to indicate hierarchy.";
    }

    public static function create_prompt_summarize($style, $writing, $language, $title, $outline) {
        return "Please create a summary of the following use case with an \"$writing\" writing style with language style \"$style\" and in \"$language\"\n\nUse Case: \"$title\" from Outline: \n\n\"$outline\"";
    }
}
?>
