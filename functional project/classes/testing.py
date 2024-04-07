import base64
import os
import io
import re
from PIL import Image
from tf_model_helper import TFModel
import sys


# Path to signature.json and model file
ASSETS_PATH = os.path.join(".", "./model")
TF_MODEL = TFModel(ASSETS_PATH)


def predict_image(image):
    image = _process_base64(image)
    return TF_MODEL.predict(image)

def _process_base64(image_data):
    image_data = re.sub(r"^data:image/.+;base64,", "", image_data)
    image_base64 = bytearray(image_data, "utf8")
    image = base64.decodebytes(image_base64)
    return Image.open(io.BytesIO(image))

if __name__ == "__main__":


    # Save string of image file path below
    img_filepath = ' '.join(sys.argv[1:])
    #img_filepath = r"C:/xampp/htdocs\botwebsite/uploads/2760640854434442/JSJcXDkfEGxKuFb.jpg"
 

    # Create base64 encoded string
    with open(img_filepath, "rb") as f:
        image_string = base64.b64encode(f.read()).decode("utf-8")

    # Get response from POST request
    # Update the URL as needed
    data = predict_image(image_string)

    top_prediction = data["predictions"][0]

    if top_prediction["confidence"] < .75:
        print("notbot")
    else:
        print(top_prediction["label"])

    # Print the top predicted label and its confidence
    #print("predicted label:\t{}\nconfidence:\t\t{}"
     #   .format(top_prediction["label"], top_prediction["confidence"]))
