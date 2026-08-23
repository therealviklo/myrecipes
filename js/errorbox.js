function removeUrlPart(url, partname) {
	let sections = url.split("?");
	if (sections.length >= 2)
	{
		let parts = sections[1].split("&");
		const res = parts.filter(part => {
			const partsections = part.split("=");
			return partsections.length == 0 || partsections[0] != partname;
		});
		sections[1] = res.join("&");
		sections = sections.filter(sec => sec != "");
	}
	return sections.join("?");
}

function removeErrorBox() {
	document.getElementById("error").remove();
	document.getElementById("grey-tint").remove();
	history.replaceState(null, "", removeUrlPart(document.location.toString(), "error"));
}