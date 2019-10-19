

import tools from "./utils/tools.js"

window.axios = require('axios');
window.axios.defaults.headers.common = {
	'X-Requested-With': 'XMLHttpRequest',
    'Content-Type': 'application/json'
};


window.axios.defaults.headers = {
	'X-CSRFToken': tools.GetCookie("csrftoken"),
    'accept': 'application/json'
};

