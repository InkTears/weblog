	<div class="comment row" data-post="<?php echo $comment->id_comment; ?>">
		<div class="col-xs-2 col-md-1"><img src="http://www.gravatar.com/avatar/<?php echo md5($comment->email); ?>" class="img-circle img-responsive" alt="avatar" /></div>
		<div class="col-xs-10 col-md-11">
			<div>
				<div class="mic-info">By: <a href="#"><?php echo $comment->username; ?></a> le <?php include '/./system/timecom.php'; ?></div>
			</div>
			<div class="comment-text"><?php echo \system\helper\String::parseCode(htmlspecialchars($comment->content)); ?></div>
			<?php if($loged): ?>
				<div class="action">
					<?php if($member->getPseudo() == $comment->username || $member->getAdmin() > 0): ?>
						<button type="button" class="btn btn-primary btn-xs edit" title="Edit" data-id="<?php echo $comment->parent_id ? $comment->parent_id : $comment->id_comment; ?>">
							<span class="glyphicon glyphicon-pencil"></span>
						</button>
						<button type="button" class="btn btn-danger btn-xs delete" title="Delete" data-id="<?php echo $comment->parent_id ? $comment->parent_id : $comment->id_comment; ?>">
							<span class="glyphicon glyphicon-trash"></span>
						</button>
					<?php endif; ?>
					<button type="button" class="btn btn-success btn-xs reply" title="Commenter" data-id="<?php echo $comment->parent_id ? $comment->parent_id : $comment->id_comment; ?>">
						<span class="glyphicon glyphicon-comment"></span>
					</button>
				</div>
			<?php endif; ?>
		</div>
	</div>