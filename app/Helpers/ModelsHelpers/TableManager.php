<?php
namespace App\Helpers\ModelsHelpers;

use App\Models\User;

class TableManager{


    /**
     * Determine if a model table has a specific column
     *
     * @param model $classMapping
     * @param string $columName
     * @return bool
     */
    public function tableHasColumn($classMapping, string $columName = 'deleted_at')
    {
        return $classMapping->getConnection()
                        ->getSchemaBuilder()
                        ->hasColumn($classMapping->getTable(), $columName);
    }

    /**
     * To delete a mass data from a db
     *
     * @param model $model
     * @param boolean $hasSoftDelete
     * @return bool
     */
    public function forceDeleteMass($model, $hasSoftDelete = false)
    {
        dd($model);
    }


    /**
     * To reset the images of a mass data from a db
     *
     * @param model $model
     * @param boolean $hasSoftDelete
     * @return bool
     */
    public function resetGaleryMass($model, $hasSoftDelete = false)
    {
        dd($model);
    }



    /**
     * To reset the basket of a mass data from a db
     *
     * @param model $model
     * @param boolean $hasSoftDelete
     * @return bool
     */
    public function resetBasket($model, $hasSoftDelete = false)
    {
        dd($model);
    }


    /**
     * To delete a mass data from a db
     *
     * @param model $model
     * @param boolean $hasSoftDelete
     * @return bool
     */
    public function deleteMass($model, $hasSoftDelete = false)
    {
        dd($model);
    }


    /**
     * To block a mass data from a db
     *
     * @param User $model
     * @param boolean $hasSoftDelete
     * @return bool
     */
    public function blockMass($model, $hasSoftDelete = false)
    {
        dd($model);
    }



    /**
     * To confirm a mass data from a db
     *
     * @param User $model
     * @param boolean $hasSoftDelete
     * @return bool
     */
    public function confirmUserEmailMass($model, $hasSoftDelete = false)
    {
        dd($model);
    }








}