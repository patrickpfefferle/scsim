<html>
<head>
    <meta charset="utf-8">
    <script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.min.js"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.steps.min.js"></script>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.steps.css'/>
</head>
<body>
<script type="text/javascript">
    $(document).ready(function () {
        $("#wizard").steps({
            bodyTag: "fieldset"
        });
    });
</script>
<div id="wizard">
    <form id="form-3" action="#">
        <h1>Account</h1>
        <fieldset>
            <legend>Account Information</legend>

            <label for="userName">User name *</label>
            <input id="userName" name="userName" type="text" class="required">
            <label for="password">Password *</label>
            <input id="password" name="password" type="text" class="required">
            <label for="confirm">Confirm Password *</label>
            <input id="confirm" name="confirm" type="text" class="required">

            <p>(*) Mandatory</p>
        </fieldset>

        <h1>Profile</h1>
        <fieldset>
            <legend>Profile Information</legend>

            <label for="name">First name *</label>
            <input id="name" name="name" type="text" class="required">
            <label for="surname">Last name *</label>
            <input id="surname" name="surname" type="text" class="required">
            <label for="email">Email *</label>
            <input id="email" name="email" type="text" class="required email">
            <label for="address">Address</label>
            <input id="address" name="address" type="text">
            <label for="age">Age (The warning step will show up if age is less than 18) *</label>
            <input id="age" name="age" type="text" class="required number">

            <p>(*) Mandatory</p>
        </fieldset>

        <h1>Warning</h1>
        <fieldset>
            <legend>You are to young</legend>

            <p>Please go away ;-)</p>
        </fieldset>

        <h1>Finish</h1>
        <fieldset>
            <legend>Terms and Conditions</legend>

            <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I
                agree
                with the Terms and Conditions.</label>
        </fieldset>
    </form>
</div>
</body>
</html>
