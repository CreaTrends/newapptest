<?php
              $default_error_message = "Please return to <a href='".url('')."'>our homepage</a>.";
            ?>
            {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}