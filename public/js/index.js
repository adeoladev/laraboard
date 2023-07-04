function toggleFilter() {
    var element = document.getElementById("filterMenu");

    if(element.classList.contains('hidden')) {
    element.classList.remove("hidden");
    } else {
    element.classList.add("hidden");     
    }
}