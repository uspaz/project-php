<div style="margin: 30px 30px">
    <h1 style="font-size:25px; font-style: italic;">Create new user</h1>
</div>

<div class="form-res"></div>

<style>
    label {
        font-size: 14px;
    }

    input {
        border: 1px solid #ccc;
        outline: none;
        padding: 10px;
        border-radius: 5px;
    }

    form {
        height: calc(100% - 50%);
        width: 50%;
        margin: 50px auto 0px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 0px 30px;
    }
</style>

<form action="./php/save_user.php" method="POST" class="FormAjax">
    <label style="display: flex; flex-direction: column; width:250px"">
        Name
        <input type="text" name="name" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40">
    </label>
    <label style="display: flex; flex-direction: column; width:250px">
        Last name
        <input type="text" name="lastName" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40">
    </label>
    <label style="display: flex; flex-direction: column; width:250px"">
        User
        <input type="text" name="user" pattern="[a-zA-Z0-9]{4,20}" maxlength="20">
    </label>
    <label style="display: flex; flex-direction: column; width:250px"">
        Email
        <input type="email" name="email" maxlength="70">
    </label>
    <label style="display: flex; flex-direction: column; width:250px"">
        Password
        <input type="password" name="password" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
    </label>
    <label style="display: flex; flex-direction: column; width:250px"">
        Confirm password
        <input type="password" name="confirmPass" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
    </label>
    <button
        style="align-self: flex-start; width: 200px; padding: 8px 0px; border: none; border-radius: 6px; outline:none; background-color: #2196f3; color: white; cursor: pointer; font-weight: bold"
        type="submit">Guardar</button>
</form>