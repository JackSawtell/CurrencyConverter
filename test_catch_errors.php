<?php
# TESTS for catch_errors.php
# Not enough params (format missing)
header('Location: catch_errors.php?from=USD&to=GBP&amnt=10.00');
# Too many params (other added)
header('Location: catch_errors.php?from=USD&to=GBP&amnt=10.00&format=xml&other=value');
# from param is not recognized
header('Location: catch_errors.php?from=AAA&to=GBP&amnt=10.00&format=xml');
# to param is not recognized
header('Location: catch_errors.php?from=USD&to=ZZZ&amnt=10.00&format=xml');
# format param is not recognized (format is yml)
header('Location: catch_errors.php?from=USD&to=GBP&amnt=10.00&format=yml');
# amnt is not a decimal value
header('Location: catch_errors.php?from=USD&to=GBP&amnt=10&format=xml');
# core files missing - temporarly rename either rates or currencies xml
# file to generate this error.
header('Location: catch_errors.php?from=USD&to=GBP&amnt=10.00&format=xml');
# format has missing value - default to xml
header('Location: catch_errors.php?from=USD&to=GBP&amnt=10.00&format=');
# good request
header('Location: catch_errors.php?from=USD&to=GBP&amnt=10&format=xml');
exit;
?>