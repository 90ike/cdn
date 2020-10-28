<?php

function video_box($post) {
    $video_url = get_post_meta($post, 'video_url', true) ? get_post_meta($post, 'video_url', true) : '';
    $video_type = get_post_meta($post, 'video_type', true);
    $video_width = get_post_meta($post, 'video_width', true) ? '640' : '520';
    $parr = qux_get_players();
    if (!$video_url) return '视频ID/URL不能为空';
    $typearr = explode("\n", $video_url);
    $listposition = get_post_meta($post, 'video_list', true) ? 'bottom' : 'right';
    $vcont = count($typearr);
    $vlistarr = array();
    $r = rand(1000, 99999);
    $jxapi_cur = trim($parr[$video_type . '_api'] ? $parr[$video_type . '_api'] : _hui('video_player_jxapi'));
    $video_logo = _hui('logo_src') ? _hui('logo_src') : '';
    $vlist = ''; //'<li><a class="list_on" href="javascript:void(0)" onclick="MP_'.$r.'.Go(0);return false;">'.$parr[$video_type].'</a></li>';
    for ($vi = 0; $vi < $vcont; $vi++) {
        $vidtemp = explode('$', $typearr[$vi]);
        if (!$vidtemp[1]) {
            $vidtemp[1] = $vidtemp[0];
            $vidtemp[0] = '第' . (intval($vi + 0) < 9 ? '0' : '') . ($vi + 1) . '集';
        }
        $vlid = $vi;
        if (isset($vlistarr[$video_type]) && count($vlistarr[$video_type]) > $vi) {
            $vlid = count($vlistarr[$video_type]);
        }
        $vlistarr[$video_type][] = array(
            'id' => $vlid,
            'pre' => $vidtemp[0],
            'video' => $vidtemp[1]
        );
        $vlist.= '<li><a href="javascript:void(0)" onclick="MP_' . $r . '.Go(' . $vlid . ', \'' . $video_type . '\');return false;">' . $vidtemp[0] . '</a></li>';
    }
    if ($jxapi_cur == 'self') {
        $jxapi_cur = '{vid}';
    }
    switch ($jxapi_cur) {
        case 'dplayer':
        case 'dplayer_live':
            video_dplayer_scripts($jxapi_cur);
            $jxapistr.= '<input type="hidden" id="mine_ifr_' . $video_type . '_' . $r . '" value=\'' . $jxapi_cur . '\'/>';
            break;
        default:
            $jxapistr.= '<input type="hidden" id="mine_ifr_' . $video_type . '_' . $r . '" value=\'<i' . 'fr' . 'ame border="0" src="' . $jxapi_cur . '" width="100%" height="' . $video_width . '" marginwidth="0" framespacing="0" marginheight="0" frameborder="0" scrolling="no" vspale="0" noresize="" allowfullscreen="true" id="minewindow_' . $video_type . '_' . $r . '"></' . 'if' . 'rame>\'/>';
    }
    
    $video_info = array('video_playing'=>'正在播放：','video_logo'=>$video_logo,'listposition'=>$listposition,'video_cover'=>post_thumbnail_src($post, 'full', false),'list_count'=>$vlid);
    wp_enqueue_script('video_player', THEME_URI . '/js/mineplayer.js', THEME_URI, THEME_VERSION, false);
    wp_add_inline_script('video_player', 'var video_info_' . $r . '=' . json_encode($video_info) . ';var video_type_' . $r . '="' . $video_type . '";var minevideo_vids_' . $r . '=' . json_encode($vlistarr) . ';var MP_' . $r . ' = new MinePlayer(' . $r . ');MP_' . $r . '.Go(0);');
    $player = '<div id="MinePlayer_' . $r . '" class="MinePlayer">
		<table border="0" cellpadding="0" cellspacing="0" id="playtop_' . $r . '" class="playtop" '. ($vcont <= 1 ? '  style="display:none;"' : '') .'><tbody><tr>
		<td width="100" id="topleft"><a target="_self" href="javascript:void(0)" onclick="MP_' . $r . '.GoPreUrl();return false;">上一集</a> <a target="_self" href="javascript:void(0)" onclick="MP_' . $r . '.GoNextUrl();return false;">下一集</a></td>
		<td id="topcc"><div id="topdes_' . $r . '" class="topdes">正在播放：' . $vin1 . '</div></td>
		<td width="100" id="topright_' . $r . '" class="topright" ' . ($listposition == 'right' ? '' : ' style="display:none;') . '"><a target="_self" href="javascript:void(0)" onclick="MP_' . $r . '.ShowList();return false;">开/关列表</a></td>
		</tr></tbody></table>
		<table border="0" cellpadding="0" cellspacing="0"><tbody><tr>
		<td id="playleft_' . $r . '" class="playleft" valign="top"></td>
		<td id="playright_' . $r . '" class="playright" valign="top">
		<div class="rightlist" id="rightlist_' . $r . '"><div id="main0" class="h2_on"><h2>播放列表</h2><ul id="sub0_' . $r . '" style="display:block">' . $vlist . '</ul></div></div>
		</td></tr></tbody></table>
		</div>' . $jxapistr . '	<div id="MineBottomList_' . $r . '" class="MineBottomList" ' . ($listposition == 'bottom' ? '' : ' style="display:none;"') . '><ul class="result_album" id="result_album_' . $r . '">' . $vlist . '</ul></div>';
    return $player;;
}

function video_scripts() {
    if (is_single() && has_post_format('video')) {
        wp_enqueue_style('_video', THEME_URI . '/css/minevideo.css', array() , THEME_VERSION);
    }
}

add_action('wp_enqueue_scripts', 'video_scripts');
function video_dplayer_scripts($key = '') {
    wp_enqueue_style('dplayer', THEME_URI . '/css/dplayer.min.css', array() , THEME_VERSION);
    if($key == 'dplayer_live'){
        wp_enqueue_script('dplayer_p2p-engine', THEME_URI . '/js/dplayer/hlsjs-p2p-engine.min.js', THEME_URI, THEME_VERSION, false); 
    }
    wp_enqueue_script('dplayer_hls', THEME_URI . '/js/dplayer/hls.js', THEME_URI, THEME_VERSION, false);
    wp_enqueue_script('dplayer_2', THEME_URI . '/js/dplayer/cbplayer2@latest.js', THEME_URI, THEME_VERSION, false);
}

function qux_get_players() {
    $players = _hui('video_player_from');
    $players = explode("\n", $players);
    $arr = array();
    foreach ($players as $p) {
        if ($p) {
            $tmp = explode('==', $p);
            if (count($tmp) >= 2) {
                $tmp[0] = trim($tmp[0]);
                $tmp[1] = trim($tmp[1]);
                $arr[$tmp[0]] = $tmp[1];
                $arr[$tmp[0] . '_api'] = isset($tmp[2]) ? trim($tmp[2]) : '';
            }
        }
    }
    return $arr;
}