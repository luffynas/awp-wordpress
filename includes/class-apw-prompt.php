<?php

class APW_Prompt {
    public static function create_prompt($style, $writing, $language) {
        return "Please use Language Style \"$style\" with Writing Style \"$writing\" and Write in language \"$language\"";
    }
}
?>
