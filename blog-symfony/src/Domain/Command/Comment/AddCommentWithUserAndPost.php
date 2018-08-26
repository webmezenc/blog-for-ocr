<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 20:39
 */

namespace App\Domain\Command\Comment;


use App\Domain\Command\CommandExecutionInterface;
use App\Entity\DTO\AddCommentDTO;
use App\Utils\Services\Comment\CommentServices;

class AddCommentWithUserAndPost implements CommandExecutionInterface
{

    /**
     * @var AddCommentDTO
     */
    private $addCommentDTO;

    /**
     * @var CommentServices
     */
    private $commentServices;

    /**
     * AddCommentWithUserAndPost constructor.
     *
     * @param AddCommentDTO $addCommentDTO
     * @param CommentServices $commentServices
     */
    public function __construct( AddCommentDTO $addCommentDTO, CommentServices $commentServices )
    {
        $this -> addCommentDTO = $addCommentDTO;
        $this -> commentServices = $commentServices;
    }


    public function executeCommand(): bool
    {
        // TODO: Implement executeCommand() method.
    }
}