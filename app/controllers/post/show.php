<?php
required_params('id');
include_model('note, comment');

// db::show_query();
$post = Post::find(Request::$params->id);
// exit;


if (!$post) {
  render("#show_empty", array('status' => 404));
  return;
}

$tags = array('include' => $post->parsed_cached_tags);

$pools = Pool::find_all(array('joins' => "JOIN pools_posts ON pools_posts.pool_id = pools.id", 'conditions' => array("pools_posts.post_id = ?", $post->id), 'order' => "pools.name", 'select' => "pools.name, pools.id", 'return' => 'model'));

// if (!empty(Request::$params->pool_id))
  // $following_pool_post = new PoolPost('find', 'first', array('conditions' => array("active AND pool_id = ? AND post_id = ?", Request::$params->pool_id)));
// else
  // $following_pool_post = new PoolPost('find', 'first', array('conditions' => array("post_id = ?", $post->id)));
  # $following_pool_post = new PoolPost('find', 'first', array('conditions' => array("active AND post_id = ?", $post->id)));

set_title(str_replace('_', ' ', $post->title_tags()));
?>