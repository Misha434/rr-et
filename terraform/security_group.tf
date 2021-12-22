resource "aws_security_group" "ec2-sg" {
  name   = "ec2-sg"
  vpc_id = aws_vpc.rret-vpc.id
}

resource "aws_security_group" "rds-sg" {
  name   = "rds-sg"
  vpc_id = aws_vpc.rret-vpc.id
}