<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 16:28
 */

namespace App\Infrastructure\Validator;


use App\Exception\InfrastructureAdapterException;
use App\Infrastructure\InfrastructureValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;

class ValidatorFactory
{
    const VALIDATOR_LIST = ["Symfony"];
    const DEFAULT_VALIDATOR = 'Symfony';

    /**
     * @param string $name
     *
     * @return InfrastructureValidatorInterface
     *
     * @throws InfrastructureAdapterException
     */
    public function create(string $name = self::DEFAULT_VALIDATOR): InfrastructureValidatorInterface {

        if( !in_array($name,self::VALIDATOR_LIST) ) {
            throw new InfrastructureAdapterException("A validator ".$name." isn't valid, validator must belong to this list : ".implode(",",self::VALIDATOR_LIST));
        }

        return $this -> getSymfonyValidator();
    }


    /**
     * @return SymfonyValidator
     */
    private function getSymfonyValidator() {
        $validatorBuilder = new ValidatorBuilder();
        $validator = $validatorBuilder  -> enableAnnotationMapping()
            -> getValidator();

        return new SymfonyValidator($validator);
    }
}