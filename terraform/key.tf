resource "aws_key_pair" "rret-kp" {
  key_name = "id_rsa_terraform"
  public_key = file("id_rsa_terraform.pub")
}