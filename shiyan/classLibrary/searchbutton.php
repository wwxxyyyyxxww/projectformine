<?php
function searchbutton($inputId,$buttonId,$onclick){
  echo <<<EOT
        <div class="am-u-sm-6 am-u-md-3 am-u-end">
        <div class="am-input-group am-input-group-sm">
            <input class="am-form-field am-round" id="$inputId" type="text"  placeholder="searching..." />
            <span class="am-input-group-btn">
                <button class="am-btn am-btn-default am-round" id="$buttonId" onclick="$onclick"><span class="am-icon-search"></span></button>
            </span>
        </div>
    </div>
EOT;
}
