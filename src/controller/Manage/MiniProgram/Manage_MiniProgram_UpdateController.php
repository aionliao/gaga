<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 28/08/2018
 * Time: 6:40 PM
 */

class Manage_MiniProgram_UpdateController extends Manage_CommonController
{

    protected function doRequest()
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        $result = [
            'errCode' => "error",
        ];
        try {
//            $name = $_POST['name'];
            $pluginId = $_POST['pluginId'];
            $name = $_POST['name'];
            $value = $_POST['value'];

            if (empty($pluginId) || empty($name)) {
                throw new Exception("error parameters");
            }

            if ($pluginId == 100) {
                throw new Exception("no permission");
            }

            if ($name == "pluginId") {
                return;
            }

            $isOk = $this->updateMiniProgramProfile($pluginId, $name, $value);

            if ($isOk) {
                $result[] = "success";
            } else {
                $result["errInfo"] = "update error";
            }

        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
            $result["errInfo"] = $e->getMessage();

        }
        echo $result;
        return;

    }

    private function updateMiniProgramProfile($pluginId, $name, $value)
    {
        $data = [
            $name => $value
        ];

        $where = [
            "pluginId" => $pluginId
        ];

        return $this->ctx->SitePluginTable->updateProfile($data, $where);
    }

}