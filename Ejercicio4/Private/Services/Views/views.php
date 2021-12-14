<?php

class Views {

    function printNavAdminUserView () {
        return '
            <nav>
                <div class="nav-wrapper">
                <a href="loans.php" class="brand-logo center">Admin Panel</a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="loans.php?action=loans"><i class="material-icons left">assignment</i>Loans</a></li>
                        <li><a href="users.php"><i class="material-icons left">assignment_ind</i>Users</a></li>
                        <li><a href="books.php"><i class="material-icons left">class</i>Books</a></li>
                        <li><a href="#"><i class="material-icons">settings</i></a></li>
                        <li><a href="index.php?action=exit"><i class="material-icons">exit_to_app</i></a></li>
                    </ul>
                </div>
            </nav>';
    }



    function printNavStandardUserView () {
        return '
            <nav>
                <div class="nav-wrapper">
                <a href="loans.php" class="brand-logo center">User Panel</a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="#"><i class="material-icons left">class</i>MyBooks</a></li>
                        <li><a href="#"><i class="material-icons">settings</i></a></li>
                        <li><a href="index.php?action=exit"><i class="material-icons">exit_to_app</i></a></li>
                    </ul>
                </div>
            </nav>';
    }

    function printAddAdminUserCheck () {
        return '
            <div class="row">
                <div>
                    <label>
                        <input type="checkbox" name="adminUser" value="adminUser"/>
                        <span>Admin user</span>
                    </label>
                </div>
            </div>';
    }

    function printLoginNow () {
        return '
            <div class="row">
                <div class="input-field col s12">
                    <a href="login.php">Login now</a>
                </div>
            </div>';
    }

    function printMessageDeleteUser (User $user) {
        return '
             <div>Do you wish to remove the user ' . $user -> getUsername() . '?</div>
             <div>
                <button class="btn waves-effect waves-custom-purple" type="submit" name="acceptDelete">Delete</button>
                <button class="btn waves-effect waves-custom-purple" type="submit">Cancel</button>
                <input type="hidden" name="usernameForDelete" value="' . $user -> getUsername() . '">
             </div>';
    }
}