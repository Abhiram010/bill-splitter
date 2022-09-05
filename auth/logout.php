<?php

// Path: bill\includes\logout.php
// session destroy
session_start();
session_unset();
session_destroy();
header("Location: ../index.php");