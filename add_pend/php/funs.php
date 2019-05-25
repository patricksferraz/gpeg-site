<?php

function value($p, $n) {
	if (isset($p[$n])) {
		return $p[$n];
	} else {
		return null;
	}
}

?>