<?php include('header.php'); ?>
        
        <div class='login'>

            <h1>Please provide a password.</h1>

            <form id="form" method='post'>

                <div class='form-field'>
                    <input type='password' name='password' placeholder='Password' class='form-input' />
                </div>
                
                <div class='form-field frontHelper'></div>
                <div class='form-field frontLoading'></div>
                
                <div class='form-field margin-top-15'>
                    <input type='button' value='Access Files' class='btn _accessBtn' />
                </div>

            </form>

        </div>

<?php include('footer.php'); ?>