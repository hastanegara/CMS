<?php

/**
 * This file is part of Bootstrap CMS by Graham Campbell.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 */

namespace GrahamCampbell\BootstrapCMS\Models;

use GrahamCampbell\BootstrapCMS\Models\Relations\Common\HasManyCommentsTrait;
use GrahamCampbell\BootstrapCMS\Models\Relations\Interfaces\HasManyCommentsInterface;
use GrahamCampbell\Credentials\Models\Relations\Common\BelongsToUserTrait;
use GrahamCampbell\Credentials\Models\Relations\Common\RevisionableTrait;
use GrahamCampbell\Credentials\Models\Relations\Interfaces\BelongsToUserInterface;
use GrahamCampbell\Credentials\Models\Relations\Interfaces\RevisionableInterface;
use GrahamCampbell\Database\Models\AbstractModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use McCool\LaravelAutoPresenter\PresenterInterface;

/**
 * This is the post model class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2013-2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Bootstrap-CMS/blob/master/LICENSE.md> AGPL 3.0
 */
class Post extends AbstractModel implements HasManyCommentsInterface, BelongsToUserInterface, RevisionableInterface, PresenterInterface
{
    use HasManyCommentsTrait, BelongsToUserTrait, RevisionableTrait, SoftDeletingTrait;

    /**
     * The table the posts are stored in.
     *
     * @type string
     */
    protected $table = 'posts';

    /**
     * The model name.
     *
     * @type string
     */
    public static $name = 'post';

    /**
     * The properties on the model that are dates.
     *
     * @type array
     */
    protected $dates = array('deleted_at');

    /**
     * The revisionable columns.
     *
     * @type array
     */
    protected $keepRevisionOf = array('title', 'summary', 'body');

    /**
     * The columns to select when displaying an index.
     *
     * @type array
     */
    public static $index = array('id', 'title', 'summary');

    /**
     * The max posts per page when displaying a paginated index.
     *
     * @type int
     */
    public static $paginate = 10;

    /**
     * The columns to order by when displaying an index.
     *
     * @type string
     */
    public static $order = 'id';

    /**
     * The direction to order by when displaying an index.
     *
     * @type string
     */
    public static $sort = 'desc';

    /**
     * The post validation rules.
     *
     * @type array
     */
    public static $rules = array(
        'title'   => 'required',
        'summary' => 'required',
        'body'    => 'required',
        'user_id' => 'required'
    );

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenter()
    {
        return 'GrahamCampbell\BootstrapCMS\Presenters\PostPresenter';
    }

    /**
     * Before deleting an existing model.
     *
     * @return void
     */
    public function beforeDelete()
    {
        $this->deleteComments();
    }
}
