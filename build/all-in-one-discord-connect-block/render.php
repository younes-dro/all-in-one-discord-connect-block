<?php
echo 'All In one Discord Connect Block Render';
echo '<pre>';
var_dump( get_block_wrapper_attributes() );
echo '</pre>';
echo '<pre>';
var_dump($attributes);
echo '</pre>';
echo  sprintf(
    '<div class="discord-connection-block" data-props="%s"></div>',
    esc_attr( wp_json_encode( [
        'btnColor'           => $btn_color,
        'disconnectBtnColor' => $ets_pmpro_btn_disconnect_color,
        'loggedInText'       => $loggedin_btn_text,
        'loggedOutText'      => $loggedout_btn_text,
        'disconnectText'     => $ets_pmpro_disconnect_btn_text,
        'roleWillAssignText' => $role_will_assign_text,
        'roleAssignedText'   => $role_assigned_text,
        'connectedUsername'  => $discord_user_name ?? '',
        'rolesHtml'          => $mapped_role_name . $default_role_name,
    ] ) )
);
