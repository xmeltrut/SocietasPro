/**
 * This is the main JavaScript file for the admin area. We have to keep
 * it in the application and then output it via a controller because
 * we need to parse in language strings. It also keeps it out of sight
 * of public site visitors.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 */

/**
 * Add a confirmation to form clicks
 *
 * @return boolean Confirmed
 */
function areYouSure () {
	return confirm("{$lang_are_you_sure}");
}

/**
 * Generate a slug on the fly
 *
 * @param string str Name of the element
 * @return string Slug
 */
function generateSlug (str) {

	// basic replacement
	str = str.toLowerCase();
	str = str.replace(/ /g, "-");
	str = str.replace(/---/g, "-");
	str = str.replace(/&/g, "and");
	
	// regular expressions
	var pattern = new RegExp("[^a-z0-9\-]", "g");
	str = str.replace(pattern, "");
	
	// return result
	return str;

}

/**
 * Tick or untick all the checkboxes
 */
function toggleAllCheckboxes () {
	if ($("#toggleCheckbox").attr("checked") == undefined) {
		$("input[name='ids[]']").attr("checked", false);
	} else {
		$("input[name='ids[]']").attr("checked", true);
	}
}
