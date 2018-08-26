<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 16:06
 */

namespace App\Infrastructure\Validator;

use App\Exception\EntityNotValidException;
use App\Infrastructure\InfrastructureValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SymfonyValidator implements InfrastructureValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;


    /**
     * @var ConstraintViolationListInterface
     */
    private $validationResult;


    /**
     * SymfonyValidator constructor.
     * @param ValidatorInterface $validator
     */

    public function __construct(ValidatorInterface $validator)
    {
       $this -> validator = $validator;
    }


    /**
     * @param $entity
     *
     * @return bool
     *
     * @throws EntityNotValidException
     */
    public function validate($entity): bool
    {
        if( !is_object($entity) ) {
            throw new EntityNotValidException("Entity must be a valid object, actual is a ".gettype($entity));
        }

        $this -> validationResult = $this -> validator -> validate($entity);

        return count($this -> validationResult) > 0 ? false:true;
    }


    /**
     * @return array  A list of constraint violation
     */
    public function getErrors(): array
    {
        $errorsTab = [];

        foreach( $this -> validationResult as $constraintViolation ) {
            $errorsTab[] = $constraintViolation -> getMessage();
        }

        return $errorsTab;
    }
}