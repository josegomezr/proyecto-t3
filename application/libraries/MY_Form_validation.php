<?php
class MY_Form_validation extends CI_Form_validation
{
    function __construct($config = array()) {
    
        parent::__construct($config);
    }

    function error_array() {
    
        if (count($this->_error_array) === 0) {
            return false;
        } else {
            return $this->_error_array;
        }
    }

    protected function _execute($row, $rules, $postdata = null, $cycles = 0) {
    
        // If the $_POST data is an array we will run a recursive call
        if (is_array($postdata)) {
            foreach ($postdata as $key => $val) {
                $this->_execute($row, $rules, $val, $cycles);
                $cycles++;
            }

            return;
        }

        // --------------------------------------------------------------------

        // If the field is blank, but NOT required, no further tests are necessary
        $callback = false;
        if (! in_array('required', $rules) and is_null($postdata)) {
        // Before we bail out, does the rule contain a callback?
            if (preg_match("/(callback_\w+(\[.*?\])?)/", implode(' ', $rules), $match)) {
                $callback = true;
                $rules = (array('1' => $match[1]));
            } else {
                return;
            }
        }

        // --------------------------------------------------------------------

        // Isset Test. Typically this rule will only apply to checkboxes.
        if (is_null($postdata) and $callback == false) {
            if (in_array('isset', $rules, true) or in_array('required', $rules)) {
                // Set the message type
                $type = (in_array('required', $rules)) ? 'required' : 'isset';

                if (! isset($this->_error_messages[$type])) {
                    if (false === ($line = $this->CI->lang->line($type))) {
                        $line = 'The field was not set';
                    }
                } else {
                    $line = $this->_error_messages[$type];
                }

                    // Build the error message
        

                    // Save the error message
                    $this->_field_data[$row['field']]['error'] = $type;

                if (! isset($this->_error_array[$row['field']])) {
                    $this->_error_array[$row['field']] = $type;
                }
            }

            return;
        }

        // --------------------------------------------------------------------

        // Cycle through each rule and run it
        foreach ($rules as $rule) {
            $_in_array = false;

            // We set the $postdata variable with the current data in our master array so that
            // each cycle of the loop is dealing with the processed data from the last cycle
            if ($row['is_array'] == true and is_array($this->_field_data[$row['field']]['postdata'])) {
            // We shouldn't need this safety, but just in case there isn't an array index
                // associated with this cycle we'll bail out
                if (! isset($this->_field_data[$row['field']]['postdata'][$cycles])) {
                    continue;
                }

                $postdata = $this->_field_data[$row['field']]['postdata'][$cycles];
                $_in_array = true;
            } else {
                $postdata = $this->_field_data[$row['field']]['postdata'];
            }

            // --------------------------------------------------------------------

            // Is the rule a callback?
            $callback = false;
            if (substr($rule, 0, 9) == 'callback_') {
                $rule = substr($rule, 9);
                $callback = true;
            }

            // Strip the parameter (if exists) from the rule
            // Rules can contain a parameter: max_length[5]
            $param = false;
            if (preg_match("/(.*?)\[(.*)\]/", $rule, $match)) {
                $rule = $match[1];
                $param  = $match[2];
            }

            // Call the function that corresponds to the rule
            if ($callback === true) {
                if (! method_exists($this->CI, $rule)) {
                    continue;
                }

                // Run the function and grab the result
                $result = $this->CI->$rule($postdata, $param);

                // Re-assign the result to the master data array
                if ($_in_array == true) {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                } else {
                    $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                }

                // If the field isn't required and we just processed a callback we'll move on...
                if (! in_array('required', $rules, true) and $result !== false) {
                    continue;
                }
            } else {
                if (! method_exists($this, $rule)) {
                // If our own wrapper function doesn't exist we see if a native PHP function does.
                    // Users can use any native PHP function call that has one param.
                    if (function_exists($rule)) {
                        $result = $rule($postdata);

                        if ($_in_array == true) {
                            $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                        } else {
                            $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                        }
                    } else {
                        log_message('debug', "Unable to find validation rule: ".$rule);
                    }

                    continue;
                }

                $result = $this->$rule($postdata, $param);

                if ($_in_array == true) {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                } else {
                    $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                }
            }

            // Did the rule test negatively?  If so, grab the error.
            if ($result === false) {
                if (! isset($this->_error_messages[$rule])) {
                    if (false === ($line = $this->CI->lang->line($rule))) {
                        $line = 'Unable to access an error message corresponding to your field name.';
                    }
                } else {
                    $line = $this->_error_messages[$rule];
                }

                // Is the parameter we are inserting into the error message the name
                // of another field?  If so we need to grab its "field label"
                if (isset($this->_field_data[$param]) and isset($this->_field_data[$param]['label'])) {
                    $param = $this->_translate_fieldname($this->_field_data[$param]['label']);
                }

                // Build the error message

                // Save the error message
                $this->_field_data[$row['field']]['error'] = $rule;

                if (! isset($this->_error_array[$row['field']])) {
                    $this->_error_array[$row['field']] = $rule;
                }

                return;
            }
        }
    }
}
