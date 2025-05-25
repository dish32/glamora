<?php
session_start(); //start the session
$isLoggedIn = isset($_SESSION['id'])&& isset($_SESSION)